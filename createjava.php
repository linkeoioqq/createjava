<?php
// ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
 if(date_default_timezone_get() != "Asia/Shanghai") date_default_timezone_set("Asia/Shanghai");
 header("Content-Type:text/html;charset=utf-8");
 echo "<br>";
?>
<head>
	    <style type="text/css">
 * {
 margin:0;
 padding:0;
 color:#000;
 }
body{

 width:410px;
zoom:1.0;
margin:0 auto;}
 #biaoge {
 width:410px;
 }
 </style>
 <script type="text/javascript" src="http://115.28.161.103/toolkit/jquery.min.1.12.4.js"></script>
 <script lanuage="javascript">
  $(document).ready(function(){
    $("#classname").focus(function(){
      if ($("#tableInterface").val() !== null || $("#tableInterface").val() !== undefined || $("#tableInterface").val() !== '') {
          var tableInterface=$("#tableInterface").val();
        var patt ='COMMENT=\'(.+)\'';
        var result= tableInterface.match(patt);
        document.write(result[1]);
        return false;
      }
      
    });
  });
 </script>
</head>
<form action="createjava.php" method="post">
  类名: <br><input type="text" name="classname" value="<?php echo $_POST['classname']; ?>"><span style="color:red">*</span>
  <br>
  说明: <br><input type="text" name="explain" value="<?php echo $_POST['explain']; ?>"><span style="color:red">*</span>
  <br>
  父表表名: <br><input type="text" name="fatherTableName" value="<?php echo $_POST['fatherTableName']; ?>">
  <br>
  当前表外键: <br><input type="text" name="biaoWaiJian" value="<?php echo $_POST['biaoWaiJian']; ?>">
  <br>
  <br>
        <div class="controls">
        <select id="category" name="category" class="required input-xlarge">
          <option value="curd">增删改查（单表）</option><option value="curd_many">增删改查（一对多）</option><option value="dao">仅持久层（dao/entity/mapper）</option><option value="treeTable">树结构表（一体）</option><option value="treeTableAndList">树结构表（左树右表）</option>
        </select>
        <span class="help-inline">
          生成结构：{包名}/{模块名}/{分层(dao,entity,service,web)}/{子模块名}/{java类}
        </span>
      </div>
    <div class="control-group">
      <label class="control-label">方案名称:</label>
      <div class="controls">
        <input id="name" name="name" class="required" type="text" value="<?php echo $_POST['name'];?>" maxlength="200"/><span style="color:red">*</span>
        <span class="help-inline"></span>
      </div>
    </div>
<div class="control-group">
      <label class="control-label">生成包路径:</label>
      <div class="controls">
        <input id="packageName" name="packageName" class="required input-xlarge" type="text" value="com.wdit.modules" maxlength="500" value="<?php echo $_POST['packageName'];?>"/>
        <span class="help-inline">建议模块包：com.wdit.modules</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">生成模块名:</label>
      <div class="controls">
        <input id="moduleName" name="moduleName" class="required input-xlarge" type="text" value="<?php echo $_POST['moduleName'];?>" maxlength="500"/><span style="color:red">*</span>
        <span class="help-inline">可理解为子系统名，例如 sys</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">生成子模块名:</label>
      <div class="controls">
        <input id="subModuleName" name="subModuleName" class="input-xlarge" type="text" value="<?php echo $_POST['subModuleName'];?>" maxlength="500"/>
        <span class="help-inline">可选，分层下的文件夹，例如 </span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">生成功能描述:</label>
      <div class="controls">
        <input id="functionName" name="functionName" class="required input-xlarge" type="text" value="<?php echo $_POST['functionName'];?>" maxlength="500"/><span style="color:red">*</span>
        <span class="help-inline">将设置到类描述</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">生成功能名:</label>
      <div class="controls">
        <input id="functionNameSimple" name="functionNameSimple" class="required input-xlarge" type="text" maxlength="500" value="<?php if(isset($_POST['functionNameSimple'])){echo $_POST['functionNameSimple'];}?>"/><span style="color:red">*</span>
        <span class="help-inline">用作功能提示，如：保存“某某”成功</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">生成功能作者:</label>
      <div class="controls">
        <input id="functionAuthor" name="functionAuthor" class="required input-xlarge" type="text" value="lk" maxlength="500"/>
        <span class="help-inline">功能开发者</span>
      </div>
    </div>

  数据表: <textarea id="tableInterface" name="tableInterface" onblur="autoset();" row="6" style="height:100px;width:410px"/><?php echo $_POST['tableInterface']; ?></textarea>
  <br>
  <input type ="submit" value="ok" style="height:21px;width:110px"/>


<?php
/*
DROP TABLE IF EXISTS information_survey;
CREATE TABLE information_survey (
  id varchar(64) DEFAULT NULL,
  name varchar(100) DEFAULT NULL,
  category varchar(10) DEFAULT NULL,
  title varchar(255) DEFAULT NULL,
  opinion longtext,
  system_list varchar(255) DEFAULT NULL,
  files_list varchar(255) DEFAULT NULL,
  reply_list longtext,
  reply_date datetime DEFAULT NULL,
  del_flag char(1) NOT NULL,
  create_by varchar(64) DEFAULT NULL,
  create_date datetime DEFAULT NULL,
  update_by varchar(64) DEFAULT NULL,
  update_date datetime DEFAULT NULL,
  remarks varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='信息化大调研';

*/

	$tableInterfaceNoempyty=$_POST["tableInterface"];
	// $tableInterfaceNoempyty=DeleteHtml($tableInterface);
preg_match('/CREATE TABLE(.+?)\(/',$tableInterfaceNoempyty,$tablenameArr);
$tablename=str_replace("`", "",$tablenameArr[1]);//表名

if (empty($_POST["classname"])) {
  $_POST["classname"]=$_POST["tableInterface"];
}
$classname=$_POST["classname"];
//
$allFieldArr=explode('(', $tableInterfaceNoempyty,"2");
$allFieldArr=explode(') ENGINE', $allFieldArr[1]);
$allFieldArr=explode(',', $allFieldArr[0]);
$fieldArr=array();
foreach ($allFieldArr as $ziduanAll) {
  $ziduanAll = preg_replace('/^( |\s)*|( |\s)*$/', '', $ziduanAll);//去首尾空格
	$value=explode(' ', $ziduanAll);//切换成字段元素
	$ziduanArr=array();
		$ziduanArr['oldName']=str_replace("`", "", $value[0]);
    $ziduanArr['name']=str_replace("_"," ",$ziduanArr['oldName']);

    $nameArr=explode(' ', lcfirst(ucwords($ziduanArr['name'])));
    $name=implode('', $nameArr);
    $ziduanArr['name']=$name;
		$value[1]=str_replace(")", "",$value[1]);
		$leixingAndSize=explode('(', $value[1]);
		$ziduanArr['type']=$leixingAndSize[0];
		$ziduanArr['size']=$leixingAndSize[1];
		// $ziduanArr['name']=$value;
		$fieldArr[]=$ziduanArr;
}
// var_dump($allFieldArr);
// preg_match('/\((.+?)ENGINE/',$tableInterfaceNoempyty,$allFieldArr);
// $allField=$allFieldArr[1];
// var_dump($allField);

function DeleteHtml($str) 
{ 
    $str = trim($str); //清除字符串两边的空格
    $str = preg_replace("/\t/","",$str); //使用正则表达式替换内容，如：空格，换行，并将替换为空。
    $str = preg_replace("/\r\n/","",$str); 
    $str = preg_replace("/\r/","",$str); 
    $str = preg_replace("/\n/","",$str); 
    $str = preg_replace("/ /","",$str);
    $str = preg_replace("/  /","",$str);  //匹配html中的空格
    return trim($str); //返回字符串
}
 echo "<pre>";
echo '<p style="font-size:24pt;color:red;text-align:center">dao文件:'.ucfirst($_POST['name']).'Dao.java<p>'."<br>";
echo '/**
 * Copyright &copy; 2012-2016 <a href="https://github.com/linke">Linke</a> All rights reserved.
 */
package com.wdit.modules.'.$_POST['moduleName'].'.dao;

import com.wdit.common.persistence.CrudDao;
import com.wdit.common.persistence.annotation.MyBatisDao;
import com.wdit.modules.'.$_POST['moduleName'].'.entity.'.ucfirst($_POST['name']).';

/**
 * '.$_POST['explain'].'DAO接口
 * @author lk
 * @version '.date("Y-m-d",time()).'
 */
@MyBatisDao
public interface '.ucfirst($_POST['name']).'Dao extends CrudDao&lt;'.ucfirst($_POST['name']).'&gt; {
  
}';
echo "<br>"."<br>"."<br>"."<br>";

echo '<p style="font-size:24pt;color:red;text-align:center">entity文件:'.ucfirst($_POST['classname']).'<p>'."<br>";
echo '/**
 * Copyright &copy; 2012-2016 <a href="https://github.com/linke">Linke</a> All rights reserved.
 */
package com.wdit.modules.'.$_POST['moduleName'].'.entity;

import org.hibernate.validator.constraints.Length;

import com.wdit.common.persistence.AdminDataEntity;

/**
 * '.$_POST['explain'].'Entity
 * @author lk
 * @version '.date("Y-m-d",time()).'
 */
public class '.ucfirst($_POST['classname']).' extends AdminDataEntity&lt;'.ucfirst($_POST['classname']).'&gt; {

  public '.ucfirst($_POST['name']).'() {
    super();
  }

  public '.ucfirst($_POST['name']).'(String id){
    super(id);
  }

  private static final long serialVersionUID = 1L;
  ';
      foreach ($fieldArr as  $value) {
        if($value['type']=="varchar"){
          $value['type']="String";
        }else if($value['type']=="int"){
          $value['type']="Integer";
        }else if($value['type']=="datetime"){
          $value['type']="Date";
        }
        
        echo " private ".$value['type']." ".$value['name'].'; //'.$value['name'].'<br>';

      }
      foreach ($fieldArr as  $value) {

        echo "@Length(min=0, max=".$value['size'].", message=\"".$value['name']."长度必须介于 0 和 ".$value['size']." 之间\")<br>";
      }
  echo '
  


  @Length(min=0, max=20, message="name长度必须介于 0 和 20 之间")
  public String getName() {
    return name;
  }

  public void setName(String name) {
    this.name = name;
  }
  
  @Length(min=0, max=11, message="age长度必须介于 0 和 11 之间")
  public String getAge() {
    return age;
  }

  public void setAge(String age) {
    this.age = age;
  }
  
  @Length(min=0, max=1, message="sex长度必须介于 0 和 1 之间")
  public String getSex() {
    return sex;
  }

  public void setSex(String sex) {
    this.sex = sex;
  }
  
  @Length(min=0, max=200, message="email长度必须介于 0 和 200 之间")
  public String getEmail() {
    return email;
  }

  public void setEmail(String email) {
    this.email = email;
  }
  
  @Length(min=0, max=200, message="title长度必须介于 0 和 200 之间")
  public String getTitle() {
    return title;
  }

  public void setTitle(String title) {
    this.title = title;
  }
  
  public String getContent() {
    return content;
  }

  public void setContent(String content) {
    this.content = content;
  }
  
  @Length(min=0, max=30, message="phone长度必须介于 0 和 30 之间")
  public String getPhone() {
    return phone;
  }

  public void setPhone(String phone) {
    this.phone = phone;
  }
  
  @Length(min=0, max=80, message="address长度必须介于 0 和 80 之间")
  public String getAddress() {
    return address;
  }

  public void setAddress(String address) {
    this.address = address;
  }
  
  public String getDetails() {
    return details;
  }

  public void setDetails(String details) {
    this.details = details;
  }
  
}';
echo "<br>"."<br>"."<br>"."<br>";

echo '<p style="font-size:24pt;color:red;text-align:center">'.ucfirst($_POST['name']).'Service文件:<p>'."<br>";
echo '/**
 * Copyright &copy; 2012-2016 <a href="https://github.com/thinkgem/jeesite">JeeSite</a> All rights reserved.
 */
package com.wdit.modules.'.$_POST['moduleName'].'.service;

import java.util.List;

import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import com.wdit.common.persistence.Page;
import com.wdit.common.service.CrudService;
import com.wdit.modules.'.$_POST['moduleName'].'.entity.'.ucfirst($_POST['name']).';
import com.wdit.modules.'.$_POST['moduleName'].'.dao.'.ucfirst($_POST['name']).'Dao;

/**
 * '.$_POST['explain'].'Service
 * @author lk
 * @version '.date("Y-m-d",time()).'
 */
@Service
@Transactional(readOnly = true)
public class '.ucfirst($_POST['name']).'Service extends CrudService&lt;'.ucfirst($_POST['name']).'Dao, '.ucfirst($_POST['name']).'&gt; {

  public '.ucfirst($_POST['name']).' get(String id) {
    return super.get(id);
  }
  
  public List&lt;'.ucfirst($_POST['name']).'&gt; findList('.ucfirst($_POST['name']).' '.lcfirst($_POST['name']).') {
    return super.findList('.lcfirst($_POST['name']).');
  }
  
  public Page&lt;'.ucfirst($_POST['name']).'&gt; findPage(Page&lt;'.ucfirst($_POST['name']).'&gt; page, '.ucfirst($_POST['name']).' '.lcfirst($_POST['name']).') {
    return super.findPage(page, '.lcfirst($_POST['name']).');
  }
  
  @Transactional(readOnly = false)
  public void save('.ucfirst($_POST['name']).' '.lcfirst($_POST['name']).') {
    super.save('.lcfirst($_POST['name']).');
  }
  
  @Transactional(readOnly = false)
  public void delete('.ucfirst($_POST['name']).' '.lcfirst($_POST['name']).') {
    super.delete('.lcfirst($_POST['name']).');
  }
  
}';
echo "<br>"."<br>"."<br>"."<br>";

echo '<p style="font-size:24pt;color:red;text-align:center">'.ucfirst($_POST['classname']).'Controller文件:<p>'."<br>";
echo '/**
 * Copyright &copy; 2012-2016 <a href="https://github.com/thinkgem/jeesite">JeeSite</a> All rights reserved.
 */
package com.wdit.modules.'.$_POST['moduleName'].'.web;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.shiro.authz.annotation.RequiresPermissions;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import com.wdit.common.config.Global;
import com.wdit.common.persistence.Page;
import com.wdit.common.web.BaseController;
import com.wdit.common.utils.StringUtils;
import com.wdit.modules.'.$_POST['moduleName'].'.entity.'.ucfirst($_POST['name']).';
import com.wdit.modules.'.$_POST['moduleName'].'.service.'.ucfirst($_POST['name']).'Service;

/**
 * '.$_POST['explain'].'Controller
 * @author lk
 * @version '.date("Y-m-d",time()).'
 */
@Controller
@RequestMapping(value = "${adminPath}/'.$_POST['moduleName'].'/'.lcfirst($_POST['name']).'")
public class '.ucfirst($_POST['name']).'Controller extends BaseController {

  @Autowired
  private '.ucfirst($_POST['name']).'Service '.lcfirst($_POST['name']).'Service;
  
  @ModelAttribute
  public '.ucfirst($_POST['name']).' get(@RequestParam(required=false) String id) {
    '.ucfirst($_POST['name']).' entity = null;
    if (StringUtils.isNotBlank(id)){
      entity = '.lcfirst($_POST['name']).'Service.get(id);
    }
    if (entity == null){
      entity = new '.ucfirst($_POST['name']).'();
    }
    return entity;
  }
  
  @RequiresPermissions("'.$_POST['moduleName'].':'.lcfirst($_POST['name']).':view")
  @RequestMapping(value = {"list", ""})
  public String list('.ucfirst($_POST['name']).' '.lcfirst($_POST['name']).', HttpServletRequest request, HttpServletResponse response, Model model) {
    Page&lt;'.ucfirst($_POST['name']).'&gt; page = '.lcfirst($_POST['name']).'Service.findPage(new Page&lt;'.ucfirst($_POST['name']).'&gt;(request, response), '.lcfirst($_POST['name']).'); 
    model.addAttribute("page", page);
    return "modules/'.$_POST['name'].'/'.lcfirst($_POST['name']).'List";
  }

  @RequiresPermissions("'.$_POST['moduleName'].':'.lcfirst($_POST['name']).':view")
  @RequestMapping(value = "form")
  public String form('.ucfirst($_POST['name']).' '.lcfirst($_POST['name']).', Model model) {
    model.addAttribute("'.lcfirst($_POST['name']).'", '.lcfirst($_POST['name']).');
    return "modules/'.$_POST['name'].'/'.lcfirst($_POST['name']).'Form";
  }

  @RequiresPermissions("'.$_POST['moduleName'].':'.lcfirst($_POST['name']).':edit")
  @RequestMapping(value = "save")
  public String save('.ucfirst($_POST['name']).' '.lcfirst($_POST['name']).', Model model, RedirectAttributes redirectAttributes) {
    if (!beanValidator(model, '.lcfirst($_POST['name']).')){
      return form('.lcfirst($_POST['name']).', model);
    }
    '.lcfirst($_POST['name']).'Service.save('.lcfirst($_POST['name']).');
    addMessage(redirectAttributes, "保存问答成功");
    return "redirect:"+Global.getAdminPath()+"/'.$_POST['moduleName'].'/'.lcfirst($_POST['name']).'/?repage";
  }
  
  @RequiresPermissions("'.$_POST['moduleName'].':'.lcfirst($_POST['name']).':edit")
  @RequestMapping(value = "delete")
  public String delete('.ucfirst($_POST['name']).' '.lcfirst($_POST['name']).', RedirectAttributes redirectAttributes) {
    '.lcfirst($_POST['name']).'Service.delete('.lcfirst($_POST['name']).');
    addMessage(redirectAttributes, "删除问答成功");
    return "redirect:"+Global.getAdminPath()+"/'.$_POST['moduleName'].'/'.lcfirst($_POST['name']).'/?repage";
  }

}';
echo "<br>"."<br>"."<br>"."<br>";

echo '<p style="font-size:24pt;color:red;text-align:center">daoXml文件:'.ucfirst($_POST['classname']).'Dao.xml<p>'."<br>";
echo htmlentities('<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE mapper PUBLIC "-//mybatis.org//DTD Mapper 3.0//EN" "http://mybatis.org/dtd/mybatis-3-mapper.dtd">
<mapper namespace="com.wdit.modules.'.$_POST['moduleName'].'.dao.'.ucfirst($_POST['classname']).'Dao">
    
  <sql id="'.lcfirst($_POST['classname']).'Columns">
    ');
    foreach ($fieldArr as  $value) {
        echo "a.".$value['oldName'].' AS "'.$value['name'].'",<br>';
      }
    // a. AS "id",
    // a.name AS "name",
    // a.age AS "age",
    // a.sex AS "sex",
    // a.email AS "email",
    // a.title AS "title",
    // a.content AS "content",
    // a.phone AS "phone",
    // a.address AS "address",
    // a.details AS "details"
    //resultType="'.$_POST['packageName'].".".$_POST['moduleName'].'.entity.'.ucfirst($_POST['classname']).'"
 echo htmlentities('a.create_by AS "createBy.id",
  a.create_date AS "createDate",
  a.del_flag AS "delFlag",
  a.remarks AS "remarks",
  a.update_by AS "updateBy.id",
  a.update_date AS "updateDate"
  </sql>
  
  <sql id="'.lcfirst($_POST['classname']).'Joins">
  </sql>
    
  <select id="get" resultType="'.$_POST['classname'].'">
    SELECT 
      <include refid="'.lcfirst($_POST['classname']).'Columns"/>
    FROM '.$tablename.' a
    <include refid="'.lcfirst($_POST['classname']).'Joins"/>
    WHERE a.id = #{id}
  </select>
  
  <select id="findList" resultType="'.ucfirst($_POST['classname']).'">
    SELECT 
      <include refid="'.lcfirst($_POST['classname']).'Columns"/>
    FROM '.$tablename.' a
    <include refid="'.lcfirst($_POST['classname']).'Joins"/>
    <where>
      a.del_flag = #{DEL_FLAG_NORMAL}
      <if test="'.$fieldArr[2]['name'].' != null and '.$fieldArr[2]['name'].' != \'\'">
        AND a.'.$fieldArr[2]['oldName'].' = #{'.$fieldArr[2]['name'].'}
      </if>
      <if test="'.$fieldArr[1]['name'].' != null and '.$fieldArr[1]['name'].' != \'\'">
        AND a.'.$fieldArr[1]['oldName'].' LIKE 
          <if test="dbName == \'oracle\'">\'%\'||#{'.$fieldArr[1]['name'].'}||\'%\'</if>
          <if test="dbName == \'mssql\'">\'%\'+#{'.$fieldArr[1]['name'].'}+\'%\'</if>
          <if test="dbName == \'mysql\'">concat(\'%\',#{'.$fieldArr[1]['name'].'},\'%\')</if>
      </if>
    </where>
    <choose>
      <when test="page !=null and page.orderBy != null and page.orderBy != \'\'">
        ORDER BY ${page.orderBy}
      </when>
      <otherwise>
      </otherwise>
    </choose>
  </select>
  
  <select id="findAllList" resultType="'.ucfirst($_POST['classname']).'">
    SELECT 
      <include refid="'.lcfirst($_POST['classname']).'Columns"/>
    FROM '.$tablename.' a
    <include refid="'.lcfirst($_POST['classname']).'Joins"/>
    <where>
      
    </where>    
    <choose>
      <when test="page !=null and page.orderBy != null and page.orderBy != \'\'">
        ORDER BY ${page.orderBy}
      </when>
      <otherwise>
      </otherwise>
    </choose>
  </select>
  
  <insert id="insert">
    INSERT INTO '.$tablename.'(
          ');
 foreach ($fieldArr as $value) {
     echo $value['oldName'].",<br>";
   }
   echo htmlentities('create_by,
      create_date,
      del_flag,
      remarks,
      update_by,
      update_date
    ) VALUES (
          ');
 foreach ($fieldArr as $value) {
     echo "#{".$value['name'].'},<br>';
   }
   echo htmlentities('#{createBy.id},
    #{createDate},
    #{delFlag},
    #{remarks},
    #{updateBy.id},
    #{updateDate}
    )
  </insert>
  
  <update id="update">
    UPDATE '.$tablename.' SET 
    ');
 foreach ($fieldArr as $value) {
    $k++;
     echo $value['oldName']." = #{".$value['name'].'},<br>';
   }
  $k=0;
   echo htmlentities('remarks = #{remarks},
   update_by = #{updateBy.id},
   update_date = #{updateDate}
    WHERE id = #{id}
  </update>
  
  <update id="delete">
    DELETE FROM '.$tablename.'
    WHERE id = #{id}
  </update>
  
</mapper>',ENT_QUOTES,"UTF-8"); 
echo "<br>"."<br>"."<br>"."<br>";

echo '<p style="font-size:24pt;color:red;text-align:center">jspList文件:<p>'."<br>";
echo htmlentities('<%@ page contentType="text/html;charset=UTF-8" %>
<%@ include file="/WEB-INF/views/include/taglib.jsp"%>
<html>
<head>
  <title>问答管理</title>
  <meta name="decorator" content="default"/>
  <script type="text/javascript">
    $(document).ready(function() {
      
    });
    function page(n,s){
      $("#pageNo").val(n);
      $("#pageSize").val(s);
      $("#searchForm").submit();
          return false;
        }
  </script>
</head>
<body>
  <ul class="nav nav-tabs">
    <li class="active"><a href="${ctx}/'.$_POST['moduleName'].'/'.lcfirst($_POST['name']).'/">问答列表</a></li>
    <shiro:hasPermission name="'.$_POST['moduleName'].':'.lcfirst($_POST['name']).':edit"><li><a href="${ctx}/'.$_POST['moduleName'].'/'.lcfirst($_POST['name']).'/form">问答添加</a></li></shiro:hasPermission>
  </ul>
  <form:form id="searchForm" modelAttribute="'.lcfirst($_POST['name']).'" action="${ctx}/'.$_POST['moduleName'].'/'.lcfirst($_POST['name']).'/" method="post" class="breadcrumb form-search">
    <input id="pageNo" name="pageNo" type="hidden" value="${page.pageNo}"/>
    <input id="pageSize" name="pageSize" type="hidden" value="${page.pageSize}"/>
    <ul class="ul-form">
      <li><label>name：</label>
        <form:input path="name" htmlEscape="false" maxlength="20" class="input-medium"/>
      </li>
      <li><label>title：</label>
        <form:input path="title" htmlEscape="false" maxlength="200" class="input-medium"/>
      </li>
      <li class="btns"><input id="btnSubmit" class="btn btn-primary" type="submit" value="查询"/></li>
      <li class="clearfix"></li>
    </ul>
  </form:form>
  <sys:message content="${message}"/>
  <table id="contentTable" class="table table-striped table-bordered table-condensed">
    <thead>
      <tr>
        <th>name</th>
        <th>title</th>
        <shiro:hasPermission name="'.$_POST['moduleName'].':'.lcfirst($_POST['name']).':edit"><th>操作</th></shiro:hasPermission>
      </tr>
    </thead>
    <tbody>
    <c:forEach items="${page.list}" var="'.lcfirst($_POST['name']).'">
      <tr>
        <td><a href="${ctx}/'.$_POST['moduleName'].'/'.lcfirst($_POST['name']).'/form?id=${'.lcfirst($_POST['name']).'.id}">
          ${'.lcfirst($_POST['name']).'.name}
        </a></td>
        <td>
          ${'.lcfirst($_POST['name']).'.title}
        </td>
        <shiro:hasPermission name="'.$_POST['moduleName'].':'.lcfirst($_POST['name']).':edit"><td>
            <a href="${ctx}/'.$_POST['moduleName'].'/'.lcfirst($_POST['name']).'/form?id=${'.lcfirst($_POST['name']).'.id}">修改</a>
          <a href="${ctx}/'.$_POST['moduleName'].'/'.lcfirst($_POST['name']).'/delete?id=${'.lcfirst($_POST['name']).'.id}" onclick="return confirmx(\'确认要删除该问答吗？\', this.href)">删除</a>
        </td></shiro:hasPermission>
      </tr>
    </c:forEach>
    </tbody>
  </table>
  <div class="pagination">${page}</div>
</body>
</html>',ENT_QUOTES,"UTF-8");
echo "<br>"."<br>"."<br>"."<br>";

echo '<p style="font-size:24pt;color:red;text-align:center">jspForm文件:<p>'."<br>";
echo htmlentities('<%@ page contentType="text/html;charset=UTF-8" %>
<%@ include file="/WEB-INF/views/include/taglib.jsp"%>
<html>
<head>
  <title>问答管理</title>
  <meta name="decorator" content="default"/>
  <script type="text/javascript">
    $(document).ready(function() {
      //$("#name").focus();
      $("#inputForm").validate({
        submitHandler: function(form){
          loading(\'正在提交，请稍等...\');
          form.submit();
        },
        errorContainer: "#messageBox",
        errorPlacement: function(error, element) {
          $("#messageBox").text("输入有误，请先更正。");
          if (element.is(":checkbox")||element.is(":radio")||element.parent().is(".input-append")){
            error.appendTo(element.parent().parent());
          } else {
            error.insertAfter(element);
          }
        }
      });
    });
  </script>
</head>
<body>
  <ul class="nav nav-tabs">
    <li><a href="${ctx}/'.$_POST['moduleName'].'/'.lcfirst($_POST['name']).'/">问答列表</a></li>
    <li class="active"><a href="${ctx}/'.$_POST['moduleName'].'/'.lcfirst($_POST['name']).'/form?id=${'.lcfirst($_POST['name']).'.id}">问答<shiro:hasPermission name="'.$_POST['moduleName'].':'.lcfirst($_POST['name']).':edit">${not empty '.lcfirst($_POST['name']).'.id?\'修改\':\'添加\'}</shiro:hasPermission><shiro:lacksPermission name="'.$_POST['moduleName'].':'.lcfirst($_POST['name']).':edit">查看</shiro:lacksPermission></a></li>
  </ul><br/>
  <form:form id="inputForm" modelAttribute="'.lcfirst($_POST['name']).'" action="${ctx}/'.$_POST['moduleName'].'/'.lcfirst($_POST['name']).'/save" method="post" class="form-horizontal">
    <form:hidden path="id"/>
    <sys:message content="${message}"/>   
    <div class="control-group">
      <label class="control-label">name：</label>
      <div class="controls">
        <form:input path="name" htmlEscape="false" maxlength="20" class="input-xlarge "/>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">age：</label>
      <div class="controls">
        <form:input path="age" htmlEscape="false" maxlength="11" class="input-xlarge "/>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">sex：</label>
      <div class="controls">
        <form:input path="sex" htmlEscape="false" maxlength="1" class="input-xlarge "/>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">email：</label>
      <div class="controls">
        <form:input path="email" htmlEscape="false" maxlength="200" class="input-xlarge "/>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">title：</label>
      <div class="controls">
        <form:input path="title" htmlEscape="false" maxlength="200" class="input-xlarge "/>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">content：</label>
      <div class="controls">
        <form:textarea path="content" htmlEscape="false" rows="4" class="input-xxlarge "/>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">phone：</label>
      <div class="controls">
        <form:input path="phone" htmlEscape="false" maxlength="30" class="input-xlarge "/>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">address：</label>
      <div class="controls">
        <form:input path="address" htmlEscape="false" maxlength="80" class="input-xlarge "/>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">details：</label>
      <div class="controls">
        <form:input path="details" htmlEscape="false" class="input-xlarge "/>
      </div>
    </div>
    <div class="form-actions">
      <shiro:hasPermission name="'.$_POST['moduleName'].':'.lcfirst($_POST['name']).':edit"><input id="btnSubmit" class="btn btn-primary" type="submit" value="保 存"/>&nbsp;</shiro:hasPermission>
      <input id="btnCancel" class="btn" type="button" value="返 回" onclick="history.go(-1)"/>
    </div>
  </form:form>
</body>
</html>',ENT_QUOTES,"UTF-8");
echo "<br>"."<br>"."<br>"."<br>";

echo "</pre>";
?>